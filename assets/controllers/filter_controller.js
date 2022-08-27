import { Controller } from '@hotwired/stimulus';
import noUiSlider from 'nouislider';


export default class extends Controller {
    static values = {
        sliderStorageCapacity: Array,
        storageMin: Number,
        storageMax: Number
    }

    connect() {
        super.connect();

        let sliderStorageCapacity = document.getElementById('formFilterSliderStorageCapacity');
        let sliderStorageCapacityValues = this.sliderStorageCapacityValue;
        let format = {
            to: function(value) {
                return sliderStorageCapacityValues[Math.round(value)];
            },
            from: function (value) {
                return sliderStorageCapacityValues.indexOf(value);
            }
        };
        let sliderStartMinValue = sliderStorageCapacityValues[0];
        let sliderStartMaxValue = sliderStorageCapacityValues[sliderStorageCapacityValues.length - 1];

        // Set the start values to the previous ones if they exist
        if (this.storageMinValue) {
            sliderStartMinValue = this._formatSliderValue(this.storageMinValue);
        }
        if (this.storageMaxValue) {
            sliderStartMaxValue = this._formatSliderValue(this.storageMaxValue);
        }

        noUiSlider.create(sliderStorageCapacity, {
            start: [sliderStartMinValue, sliderStartMaxValue],
            range: { min: 0, max: sliderStorageCapacityValues.length - 1 },
            step: 1,
            format: format,
            pips: { mode: 'steps', format: format, density: 50 },
        });
    }

    expand(event) {
        let filter_section = document.getElementById("collapseFilter");
        filter_section.classList.contains('show') ? filter_section.classList.remove('show') : filter_section.classList.add('show');
    }

    submit() {
        let sliderStorageCapacity = document.getElementById('formFilterSliderStorageCapacity');
        let sliderValues = sliderStorageCapacity.noUiSlider.get();
        document.getElementById('storageCapacityMin').value = sliderValues[0];
        document.getElementById('storageCapacityMax').value = sliderValues[1];
    }

    _formatSliderValue(rawValue) {
        if (rawValue) {
            if (rawValue === 0) {
                return rawValue;
            } else if (rawValue / 1024 >= 1) {
                return (rawValue / 1024).toString().concat('TB');
            } else {
                return rawValue.toString().concat('GB');
            }
        }
        return rawValue;
    }
}
