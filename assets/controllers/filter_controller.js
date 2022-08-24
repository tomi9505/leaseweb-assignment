import { Controller } from '@hotwired/stimulus';
import noUiSlider from 'nouislider';


export default class extends Controller {
    connect() {
        super.connect();
        let sliderStorageCapacity = document.getElementById('formFilterSliderStorageCapacity');
        noUiSlider.create(sliderStorageCapacity, {
            start: 1,
            range: {
                'min': 0,
                'max': 8
            }
        });
    }

    expand(event) {
        let filter_section = document.getElementById("collapseFilter");
        filter_section.classList.contains('show') ? filter_section.classList.remove('show') : filter_section.classList.add('show');
    }
}
