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

const prevent = (e) => {
  //this is for i element when parent element is A
  if (e.target.parentElement.nodeName === 'A' && e.target.parentElement.href.split('/').pop() === '#') {
    e.preventDefault();
    return false;
  }

  if (e.target.href.split('/').pop() === '#')
    e.preventDefault();
};

const menu = (e) => {
  if (e.target.nextElementSibling !== null) {
    if (e.target.nextElementSibling.classList.contains('d-flex')) {
      e.target.nextElementSibling.classList.remove('d-flex');
      e.target.classList.remove('open');
    } else {
      e.target.nextElementSibling.classList.add('d-flex');
      e.target.classList.add('open');
    }
  }
};

App.on('click', 'a', prevent);
// enable all submenu functions
App.on('click', 'a.has__parent', menu);
