import * as App from '../app.js';

document.getElementById('main-page-wrapper').style.minHeight
  = window.innerHeight
  - document.getElementsByTagName('footer')[0].clientHeight
  - document.getElementsByTagName('nav')[0].clientHeight  - 1 + 'px';

setTimeout(() => {
  App.OnSubmitForms();
  App.RefreshSelects();
}, 80);

App.on('click', '.render', (e) => {
  e.preventDefault();
  e.stopPropagation()
  if(e.target.classList.contains('fa')) {
    App.render({
      url: e.target.parentElement.dataset.url,
      el: e.target.parentElement.dataset.el
    })
  } else {
    App.render({
      url: e.target.dataset.url,
      el: e.target.dataset.el
    })
  }
});

App.on('click', '[data-menu="toggle"]', (e) => {
  App.toggle(e.target.dataset.target, 'd-flex');
});

App.on('click', '.menu__btn', (e) => {
  App.toggle('.left__menu__closer', 'd-flex')
  App.toggleStyle('.left__box', 'position: fixed; display: flex!important; width: 360px; left: 0; top:0;');
})

App.on('click', '.left__menu__closer', (e) => {
  App.toggleStyle('.left__box', 'position: fixed; display: flex!important; width: 360px; left: 0; top:0;');
})
