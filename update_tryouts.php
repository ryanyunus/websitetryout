<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

foreach(\App\Models\Tryout::where('category', 'pppk')->get() as $t) { 
    if(strpos($t->title, 'Guru') !== false && strpos($t->title, 'Tendik') === false) { 
        $t->update(['category' => 'pppk_guru']); 
    } elseif(strpos($t->title, 'Tendik') !== false && strpos($t->title, 'Guru') === false) { 
        $t->update(['category' => 'pppk_tendik']); 
    } else { 
        // For "Tendik dan Guru", maybe just leave it as pppk, and we show it in both
        $t->update(['category' => 'pppk']); 
    } 
}
echo "Done";
