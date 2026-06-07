<?php
App\Models\Tryout::chunk(100, function ($tryouts) {
    foreach ($tryouts as $tryout) {
        $oldTitle = $tryout->title;
        $oldDesc = $tryout->description;
        $title = $oldTitle;
        $desc = $oldDesc;

        // 1. Paket Lengkap
        if (str_contains($title, 'Paket Lengkap')) {
            $title = str_replace('PPPK Guru', 'PPPK Tendik', $title);
            $desc = str_replace('PPPK Guru', 'PPPK Tendik', $desc);
        } 
        // 2. Teknis
        elseif (str_contains($title, 'Subtes Teknis')) {
            $title = str_replace('PPPK Guru', 'PPPK Tendik', $title);
            $desc = str_replace('PPPK Guru', 'PPPK Tendik', $desc);
        }
        // 3. Manajerial, Sosial Kultural, Wawancara
        else {
            $title = str_replace('PPPK Guru', 'PPPK Tendik dan Guru', $title);
            $desc = str_replace('PPPK Guru', 'PPPK Tendik dan Guru', $desc);
        }

        if ($oldTitle !== $title || $oldDesc !== $desc) {
            $tryout->update(['title' => $title, 'description' => $desc]);
        }
    }
});
echo "Updated tryout titles successfully.\n";
