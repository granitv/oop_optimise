<?php


namespace App\Tools;


class DevTools
{
    public function prettyVarDump($element) {
        highlight_string("<?php\n\$data =\n" . var_export($element, true) . ";\n?>");
    }

    public function showArrayFirstElement($array){
        $this->prettyVarDump($array[0]);
    }

    public function showArrayElementAtIndex($array, $index){
        echo($array[$index]);
    }


}
