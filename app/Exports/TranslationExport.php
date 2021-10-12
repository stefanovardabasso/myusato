<?php

namespace App\Exports;

use App\Services\TranslatorService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use function compact;

class TranslationExport implements FromView, ShouldAutoSize, WithHeadingRow
{
    /**
     * @var TranslatorService
     */
    protected $translator;

    public function __construct()
    {
        $this->translator = new TranslatorService();
    }
    /**
     * @return View
     */
    public function view(): View
    {
        $langNames = $this->translator->getLangNames();
        $langKeys = $this->translator->getLangKeys();
        $strings = $this->translator->getStrings();

        return view('admin.translations.partials._strings-table', compact('strings', 'langNames', 'langKeys'));
    }

    public function headingRow(): int
    {
        return 1;
    }
}
