<?php

declare(strict_types=1);

namespace App\Controller;

use App\Infra\Memory\MotsJson;

class Words implements Controller
{
    public function render()
    {
        echo "Page d'accueil<br><br>";
        $words = new MotsJson();

        echo 'Motus';
        echo '
        <form action="" method="POST">
                <label for="word">Votre mot :</label>
                <input type="text" name="word">
                <button type="submit">Confirmer</button>
            </form>
            ';
       $words->findWord();

       if(isset($_POST['word'])) {
        $words->findWord();
        $words->TryWord($_POST['word']);
    }
        
    }
    
}
