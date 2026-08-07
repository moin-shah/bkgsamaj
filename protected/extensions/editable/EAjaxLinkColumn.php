<?php

Yii::import('zii.widgets.grid.CLinkColumn');

/**
 * CLinkColumn represents a grid view column that renders a ajax hyperlink in each of its data cells.
 * It uses CHtml::ajaxLink to render the link.
 *
 * @see CHtml::ajaxLink()
 *
 * @author Luke Jurgs
 * @version 0.0.3-2012-01-30
 */
class EAjaxLinkColumn extends CLinkColumn {
	/**
	 * @var string the label to the hyperlinks in the data cells. Note that the label will not
	 * be HTML-encoded when rendering. This property is ignored if {@link labelExpression} is set.
	 * @see labelExpression
	 */
	public $label = 'AJAX Link';

	/**
	 * @var array the HTML options for the data cell tags.
	 */
	public $htmlOptions = array('class' => 'ajax-link-column');

	/**
	 * @var array the HTML options for the header cell tag.
	 */
	public $headerHtmlOptions = array('class' => 'ajax-link-column');

	/**
	 * @var array the HTML options for the footer cell tag.
	 */
	public $footerHtmlOptions = array('class' => 'ajax-link-column');

	/**
	 * @var array the AJAX options for the ajax link
	 * This property is merged with {@link linkAjaxOptionsExpression} if it is set.
	 * @see linkAjaxOptionsExpression
	 */
	public $linkAjaxOptions = array();

	/**
	 * @var array an array of PHPs expression that will be evaluated for every data cell and whose result will be rendered
	 * as the URL of the hyperlink of the data cells. In this expression, the variable
	 * <code>$row</code> the row number (zero-based); <code>$data</code> the data model for the row;
	 * and <code>$this</code> the column object. This array will be merged with linkAjaxOptions
	 * @see linkAjaxOptions
	 */
	public $linkAjaxOptionsExpression;

	/**
	 * @var array the HTML options for the ajax link
	 */
	public $linkHtmlOptions = array();

	//array_walk_recursive callback target, evaluates multidimensional arrays
	private function evaluateAjaxOption(&$value, $key, $data) {
		$value = $this->evaluateExpression($value, array('data' => $data['data'], 'row' => $data['row']));
	}

	/**
	 * Renders the data cell content.
	 * This method renders a hyperlink in the data cell.
	 * @param integer $row the row number (zero-based)
	 * @param mixed $data the data associated with the row
	 */
	protected function renderDataCellContent($row, $data) {
		if ($this->urlExpression !== null) {
			$url = $this->evaluateExpression($this->urlExpression, array('data' => $data, 'row' => $row));
		} else {
			$url = $this->url;
		}
		if ($this->labelExpression !== null) {
			$label = $this->evaluateExpression($this->labelExpression, array('data' => $data, 'row' => $row));
		} else {
			$label = $this->label;
		}

		$ajaxOptions = $this->linkAjaxOptions;
		if (($this->linkAjaxOptionsExpression !== null) && (is_array($this->linkAjaxOptionsExpression))) {
			$ajaxOptionsExpression = $this->linkAjaxOptionsExpression;
			array_walk_recursive($ajaxOptionsExpression, array($this, 'evaluateAjaxOption'), array('data' => $data, 'row' => $row));
			$ajaxOptions = CMap::mergeArray($ajaxOptions, $ajaxOptionsExpression);
		}

		$label = (is_string($this->imageUrl) ? CHtml::image($this->imageUrl, $label) : $label);
		echo CHtml::ajaxLink($label, $url, $ajaxOptions, $this->linkHtmlOptions);
	}

}
