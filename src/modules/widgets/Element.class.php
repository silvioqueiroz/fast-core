<?php

class Element
{

    private $name;
    // nome TAG
    private $properties;
    // propriedade da TAG
    private $html;

    /**
     * Método construtor
     * instancia uma tag html
     *
     * @param $name =
     *            nome da tag
     */
    public function __construct($name)
    {
        // define o nome do elemento
        $this->name = $name;
    }

    /**
     * metodo __set()
     * intercepta as atribuições à propriedade do objeto
     *
     * @param $name =
     *            nome da propriedade
     * @param $value =
     *            valor
     */
    public function __set($name, $value)
    {
        // armazena os valores atribuídos
        // ao array properties
        $this->properties[$name] = $value;
    }

    /**
     * método add()
     * adiciona um elemento filho
     *
     * @param unknown_type $child            
     */
    public function add($child)
    {
        $this->children[] = $child;
    }

    /**
     * métod open
     * exibe a tag de abertura na tela
     */
    public function open()
    {
        // exibe a tag de abertura
        $html .= "<{$this->name} ";
        // echo "<{$this->name} ";
        if ($this->properties) {
            // percorre as propriedades
            foreach ($this->properties as $name => $value) {
                $html .= "{$name}=\"{$value}\"";
                // echo "{$name}=\"{$value}\"";
            }
        }
        $html .= ">";
        // echo ">";
    }

    /**
     * método show
     * exibe a tag na tela, juntamente com seu conteúdo
     */
    public function show()
    {
        // abre a tag
        $this->open();
        // echo "\n";
        // $this->html = "\n";
        // se possui conteúdo
        if ($this->children) {
            // percorre todos objetos filhos
            foreach ($this->children as $child) {
                // se for objeto
                if (is_object($child)) {
                    $this->html .= $child->show();
                } else 
                    if (is_string($child) or (is_numeric($child))) {
                        // se for texto
                        $this->html .= $child;
                        // echo $child;
                    }
            }
        }
        // fecha a tag
        $this->close();
        return $this->html;
    }

    /**
     * método close
     * Fecha uma tag html
     */
    private function close()
    {
        $this->html .= "</{$this->name}>\n";
        // echo "</{$this->name}>\n";
    }

    public function __toString()
    {
        $this->show();
        return $this->html;
    }
}

?>