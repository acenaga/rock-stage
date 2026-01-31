<?php

namespace App\Filament\Resources\Videos\Pages;

use App\Filament\Resources\Videos\VideoResource;
use App\Jobs\ProcessYouTubeVideo;
use App\Models\Video;
use App\Services\YouTubeService; // <--- IMPORTANTE: Importar el Job
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListVideos extends ListRecords
{
    protected static string $resource = VideoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('importar_videos')
                ->label('Importar desde YouTube')
                ->icon('heroicon-o-arrow-down-tray')
                ->modal()
                ->modalHeading('Importar Videos desde YouTube')
                ->modalDescription('Importa videos utilizando sus IDs de YouTube.')
                ->modalSubmitActionLabel('Importar')
                ->modalCancelActionLabel('Cancelar')
                ->form([
                    \Filament\Forms\Components\Textarea::make('manual_ids')
                        ->label('IDs de YouTube (uno por línea)')
                        ->placeholder("dQw4w9WgXcQ\notro_id_aqui")
                        ->rows(8)
                        ->helperText('Pega los IDs, uno por línea.')
                        ->required(),
                ])
                ->action(function (array $data): void {
                    // Limpieza de datos (igual que tenías)
                    $ids = explode("\n", $data['manual_ids'] ?? '');
                    $ids = array_filter(array_map('trim', $ids));
                    $ids = array_unique($ids);

                    if (empty($ids)) {
                        Notification::make('import_error')
                            ->title('Error')
                            ->body('No se encontraron IDs válidos.')
                            ->danger()
                            ->send();

                        return;
                    }
                    $processedCount = 0;
                    foreach ($ids as $id) {
                        // Validación de formato YouTube (11 caracteres, alfanumérico y guiones)
                        if (strlen($id) === 11 && preg_match('/^[a-zA-Z0-9_-]+$/', $id)) {
                            // 1. Creamos el registro en estado "Pendiente"
                            $video = Video::firstOrCreate(
                                ['id_youtube' => $id], // Buscamos por ID para no duplicar
                                [
                                    'title' => 'Procesando ID: '.$id.'...', // Título temporal
                                    'description' => 'Esperando respuesta de YouTube...',
                                    'thumbnail_url' => null, // Dejamos null o una imagen de "loading"
                                    'duration' => null,
                                    'band_name' => null,
                                    'region' => null,
                                ]
                            );

                            // 2. Disparamos el Job para que busque la info real en segundo plano
                            // Esto evita que la página se congele si importas 50 videos
                            // ProcessYouTubeVideo::dispatch($video);
                            $service = new YouTubeService;
                            $data = $service->getVideoDetails($id);
                            if ($data) {
                                $video->update([
                                    'title' => $data['title'],
                                    'thumbnail_url' => $data['thumbnail_url'],
                                    'description' => $data['description'],
                                    'duration' => $data['duration'],
                                    'band_name' => $data['band_name'],
                                    'status' => 'completed',
                                ]);
                            } else {
                                $video->update(['status' => 'failed']);
                            }
                            $processedCount++;
                        }
                    }

                    if ($processedCount > 0) {
                        Notification::make('import_success')
                            ->title('Procesamiento iniciado')
                            ->body("Se enviaron {$processedCount} videos a la cola de procesamiento. Actualiza la página en unos segundos.")
                            ->success()
                            ->send();
                    } else {
                        Notification::make('import_warning')
                            ->title('Advertencia')
                            ->body('Ningún ID tenía el formato válido de YouTube (11 caracteres).')
                            ->warning()
                            ->send();
                    }
                }),
        ];
    }

    // ... Resto de tus métodos (getTableActions, etc) igual que antes
    protected function getTableActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function getTableBulkActions(): array
    {
        return [
            Actions\BulkActionGroup::make([
                Actions\DeleteBulkAction::make(),
            ]),
        ];
    }
}
