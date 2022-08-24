import { Controller } from '@hotwired/stimulus';
import noUiSlider from 'nouislider';
import wNumb from 'wnumb';


export default class extends Controller {
    static values = {
        sliderStorageCapacity: Array
    }

    connect() {
        super.connect();

        let sliderStorageCapacity = document.getElementById('formFilterSliderStorageCapacity');
        let sliderStorageCapacityValues = this.sliderStorageCapacityValue;
        // let format = {
        //     to: function(value) {
        //         return sliderStorageCapacityValues[Math.round(value)];
        //     },
        //     from: function (value) {
        //         return sliderStorageCapacityValues.indexOf(Number(value));
        //     }
        // };
        let format = wNumb({
            encoder: function(value) {
                if (value.toString().includes("TB")) {
                    value = value.split(" ")[0].parseInt() * 1024;
                } else {
                    value = value.split(" ")[0].parseInt();
                }
                return sliderStorageCapacityValues.indexOf(Number(value));
            },
            decoder: function(value) {
                value = sliderStorageCapacityValues[Math.round(value)];
                if (value / 1024 >= 1) {
                    value = value / 1024;
                    return value.toString().concat(" TB");
                } else {
                    return value.toString().concat(" GB");
                }
            }
        });

        noUiSlider.create(sliderStorageCapacity, {
            start: [sliderStorageCapacityValues[0], sliderStorageCapacityValues[sliderStorageCapacityValues.length - 1]],
            range: { min: 0, max: sliderStorageCapacityValues.length - 1 },
            step: 1,
            format: format,
            pips: { mode: 'steps', format: format }
        });
    }

    expand(event) {
        let filter_section = document.getElementById("collapseFilter");
        filter_section.classList.contains('show') ? filter_section.classList.remove('show') : filter_section.classList.add('show');
    }
}
