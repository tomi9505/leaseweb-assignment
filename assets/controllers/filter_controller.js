import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    // connect() {
    //     this.element.textContent = 'Hello Stimulus! Edit me in assets/controllers/hello_controller.js';
    // }
    expand(event) {
        event.preventDefault();
        console.log('Expand called');
    }
}
