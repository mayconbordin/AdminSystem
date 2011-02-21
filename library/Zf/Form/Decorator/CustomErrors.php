<?php

class Zf_Form_Decorator_CustomErrors extends Zend_Form_Decorator_Abstract
{
 	public function render($content)
    {
    	$element = $this->getElement();
        $view    = $element->getView();
        if (null === $view) {
            return $content;
        }

        $errors = $element->getMessages();
        if (empty($errors)) {
            return $content;
        }

        $separator = $this->getSeparator();
        $placement = $this->getPlacement();
        $errors    = $view->formErrors($errors, $this->getOptions());
        
        $errors = str_replace('<li>', '', $errors);
        $errors = str_replace('</li>', '. ', $errors);
        $errors = str_replace('<ul class="errors">', '<td><div class="error-left"></div><div class="error-inner">', $errors);
		$errors = str_replace('</ul>', '</div></td>', $errors);
        
        switch ($placement) {
            case self::APPEND:
                return $content . $separator . $errors;
            case self::PREPEND:
                return $errors . $separator . $content;
        }
    }
}