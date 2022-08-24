import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    // connect() {
    //     this.element.textContent = 'Hello Stimulus! Edit me in assets/controllers/hello_controller.js';
    // }
    expand(event) {
        // event.preventDefault();
        // console.log('Expand called');
        let filter_section = document.getElementById("collapseFilter");
        filter_section.classList.contains('show') ? filter_section.classList.remove('show') : filter_section.classList.add('show');
    }
}
