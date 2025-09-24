<?php
// Clase para construir formularios HTML de forma programática.
class Formulario {
    // Propiedades de la clase.
    private $action;
    private $method;
    private $campos = [];

    /**
     * Constructor de la clase Formulario.
     * Se utiliza para inicializar la acción y el método del formulario.
     *
     * @param string $action URL a la que se enviarán los datos del formulario.
     * @param string $method Método HTTP (POST o GET) para el envío de datos.
     */
    public function __construct($action, $method) {
        $this->action = $action;
        $this->method = $method;
    }

    /**
     * Agrega un campo de entrada (input) al formulario.
     *
     * @param string $label El texto de la etiqueta del campo.
     * @param string $type El tipo de input (text, email, tel, etc.).
     * @param string $name El nombre del campo.
     * @param bool $required Si el campo es obligatorio.
     */
    public function agregarCampo($label, $type, $name, $required = false) {
        $required_attr = $required ? 'required' : '';
        $this->campos[] = "<label for='$name'>$label:</label><input type='$type' id='$name' name='$name' $required_attr>";
    }

    /**
     * Agrega un área de texto (textarea) al formulario.
     */
    public function agregarTextarea($label, $name, $rows = 4, $required = false) {
        $required_attr = $required ? 'required' : '';
        $this->campos[] = "<label for='$name'>$label:</label><textarea id='$name' name='$name' rows='$rows' $required_attr></textarea>";
    }

    /**
     * Agrega un campo de selección (select) al formulario.
     */
    public function agregarSelect($label, $name, $options, $required = false) {
        $required_attr = $required ? 'required' : '';
        $select_html = "<label for='$name'>$label:</label><select id='$name' name='$name' $required_attr>";
        foreach ($options as $value => $text) {
            $select_html .= "<option value='$value'>$text</option>";
        }
        $select_html .= "</select>";
        $this->campos[] = $select_html;
    }

    /**
     * Genera el HTML completo del formulario.
     *
     * @return string El HTML del formulario.
     */
    public function generarFormulario() {
        $html = "<form action='{$this->action}' method='{$this->method}'>";
        foreach ($this->campos as $campo) {
            $html .= "<p>$campo</p>";
        }
        $html .= "<input type='submit' value='Enviar'>";
        $html .= "</form>";
        return $html;
    }
}
?>