// import "bootstrap"
// import Artplayer from 'artplayer';
// import Swiper, {Navigation, Pagination} from 'swiper';
// import 'fslightbox';

/**
 * General theme js class
 */
class Theme {
  constructor() {
    $(document).ready(this.ready.bind(this))
    $(window).on("load", this.load.bind(this))
  }

  /**
   * Method called after document ready.
   */
  ready() {
    this.bind()
  }

  /**
   * Method called after window loaded.
   */
  load() {}

  bind() {}
}

export default new Theme()
