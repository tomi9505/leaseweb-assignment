import { Controller } from '@hotwired/stimulus';
import noUiSlider from 'nouislider';


export default class extends Controller {
    static values = {
        sliderStorageCapacity: Array
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

        noUiSlider.create(sliderStorageCapacity, {
            start: [sliderStorageCapacityValues[0], sliderStorageCapacityValues[sliderStorageCapacityValues.length - 1]],
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
}
