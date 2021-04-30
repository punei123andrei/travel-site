import axios from "axios";
import Axios from "axios";

export default class Client {
  constructor() {
    this.injectHtml();
    this.form = document.querySelector(".client-area__form");
    this.field = document.querySelector(".client-area__input");
    this.content = document.querySelector(".client-area__content-area");
    this.events();
  }
  events() {
    this.form.addEventListener("submit", (e) => {
      e.preventDefault();
      this.sendRequest();
    });
  }
  sendRequest() {
    axios
      .post(
        "https://focused-brown-3276c0.netlify.app/.netlify/functions/secret-area",
        { password: this.field.value }
      )
      .then((response) => {
        this.form.remove();
        this.content.innerHTML = response.data;
      })
      .catch(() => {
        this.content.innerHTML = `
        <p class="client-area__error">That secret phrase is not correct</p>
        `;
        this.field.value = "";
        this.field.focus();
      });
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
