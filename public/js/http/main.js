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
  if (e.target.classList.contains('fa')) {
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
  App.toggleStyle('.left__box', 'position: fixed; display: flex!important; width: 100%; left: 0; top:0; z-index: 100; overflow: auto;');
})

App.on('click', '.left__menu__closer', (e) => {
  App.toggle('.left__menu__closer', 'd-flex')
  App.toggleStyle('.left__box', 'position: fixed; display: flex!important; width: 100%; left: 0; top:0; z-index: 100; overflow: auto;');
})

const prevent = (e) => {
  //this is for i element when parent element is A
  if (e.target.parentElement.nodeName === 'A' && e.target.parentElement.href.split('/').pop() === '#') {
    e.preventDefault();
    return false;
  }

  if (e.target.href !== undefined && e.target.href.split('/').pop() === '#')
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

App.on('click', 'a.has__parent img', (e) => {
  let el = e.target.parentElement.nextElementSibling;
  if (el !== null) {
    if (el.classList.contains('d-flex')) {
      el.classList.remove('d-flex');
      el.classList.remove('open');
    } else {
      el.classList.add('d-flex');
      el.classList.add('open');
    }
  }
});

App.on('click', 'button[data-toggle="buyable"]', (e) => {
  e.target.classList.remove('button__not__active');
  e.target.classList.add('is__tab__button__active');
  let selector = document.querySelector('button[data-toggle="sellable"]');
  selector.classList.remove('is__tab__button__active')
  selector.classList.add('button__not__active')
  let hideTab = document.querySelector('div[data-target="sellable"]');
  hideTab.setAttribute('style', 'display:none;')
  let showTab = document.querySelector('div[data-target="buyable"]');
  showTab.setAttribute('style', '');
});

App.on('click', 'button[data-toggle="sellable"]', (e) => {
  e.target.classList.remove('button__not__active');
  e.target.classList.add('is__tab__button__active');
  let selector = document.querySelector('button[data-toggle="buyable"]');
  selector.classList.remove('is__tab__button__active')
  selector.classList.add('button__not__active')
  let hideTab = document.querySelector('div[data-target="buyable"]');
  hideTab.setAttribute('style', 'display:none;')
  let showTab = document.querySelector('div[data-target="sellable"]');
  showTab.setAttribute('style', '');
});

App.on('click', '.wiki-box__mobile-container', (e) => {
  App.toggle('.wiki__box--search', 'd-flex');
  App.toggle('.mobile__search__closer', 'd-flex');
})

App.on('click', '.mobile__search__closer', (e) => {
  App.toggle('.mobile__search__closer', 'd-flex');
  App.toggle('.wiki__box--search', 'd-flex');
})
