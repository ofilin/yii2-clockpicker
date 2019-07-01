<?php

namespace ofilin\clockpicker;

use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\base\InvalidConfigException;
use yii\base\Model;

class ClockPickerWidget extends Widget
{
    /**
     * @var array The HTML attribute options for the input tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = [];

    /**
     * @var array {@link https://github.com/weareoutman/clockpicker clockpicker options} to manage the clockpicker itself.
     */
    public $pluginOptions = [];

    /**
     * @var Model|null The data model that this widget is associated with.
     */
    public $model;

    /**
     * @var string|null The model attribute that this widget is associated with.
     */
    public $attribute;

    /**
     * @var string|null The input name. This must be set if `model` and `attribute` are not set.
     */
    public $name;

    /**
     * @var string|null The input value.
     */
    public $value;

    /**
     * @var string|null Selector pointing to textarea to initialize redactor for.
     * Defaults to `null` meaning that textarea does not exist yet and will be rendered by this widget.
     */
    public $selector;

    public function init()
    {
        if ($this->name === null && $this->selector === null && !$this->hasModel()) {
            throw new InvalidConfigException("Either 'name', or 'model' and 'attribute' properties must be specified.");
        }
        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->hasModel() ? Html::getInputId($this->model, $this->attribute) : $this->getId();
        }
        if ($this->selector === null) {
            $this->selector = '#' . $this->options['id'];
        }
        parent::init();

    }

    protected function hasModel()
    {
        return $this->model instanceof Model && $this->attribute !== null;
    }

    public function run()
    {
        $this->registerAsset();
        $this->registerClientScript();

        $this->options = ArrayHelper::merge(['class' => 'form-control'], $this->options);
        if ($this->hasModel()) {
            $input = Html::activeTextInput($this->model, $this->attribute, $this->options);
        } else {
            $input = Html::textInput($this->name, $this->value, $this->options);
        }

        $container = Html::beginTag('div', ['class' => 'input-group']);
        $container .= $input;

        $icon = Html::tag('i', null, ['class'=>'glyphicon glyphicon-time']);
        $container .= Html::tag('span', $icon, ['class'=>'input-group-addon']);

        $container .= Html::endTag('div');
        $container .= Html::tag('div', null, ['class' => 'help-block']);
        return $container;
    }

    protected function registerAsset()
    {
        $view = $this->getView();
        ClockPickerAsset::register($view);
    }

    protected function registerClientScript()
    {
        $selector = Json::encode($this->selector);
        $config = [
            'placement' => 'top',
            'autoclose' => true,
        ];
        $config = Json::encode(ArrayHelper::merge($config, $this->pluginOptions));
        $this->view->registerJs("jQuery($selector).clockpicker($config);", $this->view::POS_READY);
    }
}