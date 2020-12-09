import * as App from '../../app.js';

let myMethod = () => {
  App.on('click', 'img.img-fluid', (e) => {
    let elem = document.createElement('textarea');
    document.body.appendChild(elem);
    elem.value = `<img class="img-fluid" src="${e.target.getAttribute('src')}"> `;
    elem.select();
    document.execCommand("copy");
    document.body.removeChild(elem);
    e.target.setAttribute('style', 'border: 3px solid green');
    setTimeout(() => {
      e.target.setAttribute('style', '');
    }, 1500);
  })

  App.on('dblclick', 'img.img-fluid', (e) => {
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
    e.target.setAttribute('style', 'border: 3px solid blue');
    setTimeout(() => {
      e.target.setAttribute('style', '');
    }, 1500);
  })
}

App.afterRender(myMethod);
