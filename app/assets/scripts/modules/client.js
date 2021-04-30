export default class Client {
  constructor() {
    this.injectHtml();
  }
  injectHtml() {
    document.body.insertAdjacentHTML(
      "beforeend",
      `
        
        `
    );
  }
}
