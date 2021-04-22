import * as App from '../../app.js';

let myMethod = () => {
  App.on('click', 'img.img-fluid', (e) => {
    document.querySelectorAll('img.img-fluid').forEach((e) => e.setAttribute('style', ''));
    let elem = document.createElement('textarea');
    document.body.appendChild(elem);
    elem.value = `<img class="img-fluid" src="${e.target.getAttribute('src')}"> `;
    elem.select();
    document.execCommand("copy");
    document.body.removeChild(elem);
    e.target.setAttribute('style', 'border: 1px solid green; opacity: .7');
  })

  App.on('dblclick', 'img.img-fluid', (e) => {
    document.querySelectorAll('img.img-fluid').forEach((e) => e.setAttribute('style', ''));
    let elem = document.createElement('textarea');
    document.body.appendChild(elem);

    if (e.target.dataset.ismonster !== '') {
      elem.value = `<a href="monsters/show/${e.target.dataset.ismonster}">
        <img class="img-fluid" src="${e.target.getAttribute('src')}">
      </a>`;
    } else {
      elem.value = `<a data-title="${e.target.dataset.isitem}" href="items/show/${e.target.dataset.isitem}">
        <img class="img-fluid" src="${e.target.getAttribute('src')}">
      </a>`;
    }
    elem.select();
    document.execCommand("copy");
    document.body.removeChild(elem);
    e.target.setAttribute('style', 'border: 1px solid blue; opacity: .7');
  })
}

App.afterRender(myMethod);
