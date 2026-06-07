<?php
App\Models\Tryout::chunk(100, function ($tryouts) {
    foreach ($tryouts as $tryout) {
        $title = str_replace('Tenaga Kependidikan', 'Guru', $tryout->title);
        $desc = str_replace(['Tenaga Kependidikan', 'Tendik'], ['Guru', 'Guru'], $tryout->description);
        
        if ($tryout->title !== $title || $tryout->description !== $desc) {
            $tryout->update(['title' => $title, 'description' => $desc]);
        }
    }
});
echo "Updated tryout titles successfully.\n";
