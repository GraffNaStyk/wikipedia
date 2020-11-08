import * as App from '../../app.js';

let myMethod = () => {
  App.on('click', 'img.img-fluid', (e) => {
    let elem = document.createElement('textarea');
    document.body.appendChild(elem);
    elem.value = `<img class="img-fluid" src="${e.target.getAttribute('src')}"> `;
    elem.select();
    document.execCommand("copy");
    document.body.removeChild(elem);
  })
}

App.afterRender(myMethod);
