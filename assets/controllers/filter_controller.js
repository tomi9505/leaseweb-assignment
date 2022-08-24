import { Controller } from '@hotwired/stimulus';
import noUiSlider from 'nouislider';


export default class extends Controller {
    static values = {
        sliderStorageCapacity: Array
    }

    connect() {
        super.connect();

        let sliderStorageCapacity = document.getElementById('formFilterSliderStorageCapacity');
        let format = {
            to: function(value) {
                return this.sliderStorageCapacityValue[Math.round(value)];
            },
            from: function (value) {
                return this.sliderStorageCapacityValue.indexOf(Number(value));
            }
        };

        noUiSlider.create(sliderStorageCapacity, {
            start: [this.sliderStorageCapacityValue[0], this.sliderStorageCapacityValue[this.sliderStorageCapacityValue.length - 1]],
            range: { min: 0, max: this.sliderStorageCapacityValue.length - 1 },
            step: 1,
            format: format,
        });
    }

    expand(event) {
        let filter_section = document.getElementById("collapseFilter");
        filter_section.classList.contains('show') ? filter_section.classList.remove('show') : filter_section.classList.add('show');
    }
}
