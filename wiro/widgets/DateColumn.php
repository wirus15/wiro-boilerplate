<?php

namespace wiro\widgets;

use CHtml;
use TbDataColumn;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class DateColumn extends TbDataColumn
{
    public $format = 'long';
    public $options = array();

    public function init()
    {
	parent::init();
	if ($this->grid->filter && !$this->filter) {
	    $this->filter = $this->grid->controller->widget('bootstrap.widgets.TbDateRangePicker', array(
		'model' => $this->grid->filter,
		'attribute' => $this->name,
		'callback' => 'js:function() { $("#' . CHtml::activeId($this->grid->filter, $this->name) . '").change(); }',
		'options' => $this->options,
	    ), true);
	}
    }

    /**
     * Renders the data cell content.
     * This method evaluates {@link value} or {@link name} and renders the result.
     * @param integer $row the row number (zero-based)
     * @param mixed $data the data associated with the row
     */
    protected function renderDataCellContent($row, $data)
    {
	if ($this->value !== null)
	    $value = $this->evaluateExpression($this->value, array('data' => $data, 'row' => $row));
	elseif ($this->name !== null)
	    $value = App::dateFormatter()->formatDateTime(CHtml::value ($data, $this->name), $this->format, null);
	echo $value === null ? $this->grid->nullDisplay : $this->grid->getFormatter()->format($value, $this->type);
    }
}
