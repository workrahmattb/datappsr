<?php

namespace App\Filament\Resources\Pendaftarans\Pages;

use App\Filament\Resources\Pendaftarans\PendaftaranResource;
use App\Filament\Resources\Mtsputris\Schemas\MtsputriForm;
use App\Models\Pendaftaran;
use App\Models\Mtsputri;
use App\Models\Mtsputra;
use App\Models\Maputri;
use App\Models\Maputra;
use Filament\Resources\Pages\Page;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;

class DaftarUlangPendaftaran extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = PendaftaranResource::class;

    protected string $view = 'filament.resources.pendaftarans.pages.daftar-ulang-pendaftaran';

    public ?array $data = [];
    
    public Pendaftaran $record;

    public function mount(int | string $record): void
    {
        $this->record = Pendaftaran::findOrFail($record);
        
        // Check if already completed
        if ($this->record->status_pendaftaran === 'completed') {
            Notification::make()
                ->warning()
                ->title('Pendaftaran Sudah Selesai')
                ->body('Siswa ini sudah menyelesaikan pendaftaran ulang.')
                ->send();
                
            $this->redirect(PendaftaranResource::getUrl('index'));
            return;
        }

        $this->form->fill($this->record->toArray());
    }

    public function form(Form $form): Form
    {
        return MtsputriForm::configure($form);
    }

    public function save(): void
    {
        try {
            DB::beginTransaction();

            $data = $this->form->getState();
            
            // Get target model class
            $modelClass = $this->record->getTargetModelClass();
            
            if (!$modelClass) {
                throw new \Exception('Jenjang pendidikan tidak valid');
            }

            // Create student record in the appropriate table
            $student = $modelClass::create($data);

            // Update pendaftaran status
            $this->record->update([
                'status_pendaftaran' => 'completed',
                'student_id' => $student->id,
                'student_type' => $this->record->getStudentType(),
            ]);

            DB::commit();

            Notification::make()
                ->success()
                ->title('Pendaftaran Ulang Berhasil')
                ->body('Data siswa berhasil disimpan ke ' . $this->record->jenjang_pendidikan)
                ->send();

            $this->redirect(PendaftaranResource::getUrl('index'));

        } catch (\Exception $e) {
            DB::rollBack();
            
            Notification::make()
                ->danger()
                ->title('Pendaftaran Ulang Gagal')
                ->body('Terjadi kesalahan: ' . $e->getMessage())
                ->send();
        }
    }

    protected function getFormActions(): array
    {
        return [
            \Filament\Actions\Action::make('save')
                ->label('Simpan')
                ->submit('save')
                ->keyBindings(['mod+s']),
            \Filament\Actions\Action::make('cancel')
                ->label('Batal')
                ->url(PendaftaranResource::getUrl('index'))
                ->color('gray'),
        ];
    }

    public function getTitle(): string
    {
        return 'Daftar Ulang - ' . $this->record->nama;
    }
}
