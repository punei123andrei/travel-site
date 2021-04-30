export default class Client {
  constructor() {
    this.injectHtml();
  }
  injectHtml() {
    document.body.insertAdjacentHTML(
      "beforeend",
      `
      <div class="client-area">
      <div class="wrapper wrapper--medium">
        <h2 class="section-title section-title--blue">Secret Client Area</h2>
        <form class="client-area__form" action="">
          <input
            class="client-area__input"
            type="text"
            placeholder="Enter the secret phrase"
          />
          <button class="btn btn--orange">Submit</button>
        </form>
        <div class="client-area__content-area"></div>
      </div>
    </div>
        `
    );
  }
}
