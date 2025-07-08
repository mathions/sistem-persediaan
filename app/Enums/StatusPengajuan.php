<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum StatusPengajuan: string implements HasColor, HasIcon, HasLabel
{
    case Diajukan = 'diajukan';
    case Direkap = 'direkap';
    case Disetujui = 'disetujui';
    case Ditolak = 'ditolak';

    public function getLabel(): string
    {
        return match ($this) {
            self::Diajukan => 'Diajukan',
            self::Direkap => 'Direkap',
            self::Disetujui => 'Disetujui',
            self::Ditolak => 'Ditolak',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Diajukan => 'info',
            self::Direkap => 'warning',
            self::Disetujui => 'success',
            self::Ditolak => 'danger',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Diajukan => 'heroicon-m-sparkles',
            self::Direkap => 'heroicon-m-clipboard-document-list',
            self::Disetujui => 'heroicon-m-check-circle',
            self::Ditolak => 'heroicon-m-x-circle',
        };
    }
}
