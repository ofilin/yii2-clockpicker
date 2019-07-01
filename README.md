## yii2-clockpicker

ClockPicker https://weareoutman.github.io/clockpicker/

### Installation

Add the package to your `composer.json`:

    {
        "require": {
            "ofilin/yii2-clockpicker": "^0.1"
        }
    }

and run `composer update` or alternatively run `composer require ofilin/yii2-clockpicker:^0.1`

### Usage


```
use ofilin\clockpicker\ClockPickerWidget;
```

```
<?= $form->field($model, 'time_field')->label(false)->widget(ClockPickerWidget::class) ?>
```