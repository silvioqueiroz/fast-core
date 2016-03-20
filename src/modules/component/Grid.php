<?php

class GridComponent
{

    public $dataProvider;

    private $labelName = "name";

    private $numaberOfColumns = 4;

    function __toString()
    {
        $content = null;
        $columnNumber = - 1;
        $table = new Element('table');
        $table->border = 0;
        $table->bordercolor = "black";
        
        $tboby = new Element('tbody');
        $table->add($tboby);
        
        if ($this->dataProvider) {
            $tr = null; // ew Element('tr');
            for ($item = 0; $item < count($this->dataProvider); $item ++) {
                if (($item % $this->numaberOfColumns) == 0) {
                    $tr = new Element('tr');
                    $tboby->add($tr);
                }
                $td = new Element('td');
                $td->add($this->dataProvider[$item]->name);
                $td->width = "25%";
                $tr->add($td);
            }
        }
        return $table->show();
    }
}

?>