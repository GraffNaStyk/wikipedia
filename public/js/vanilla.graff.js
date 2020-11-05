let urls = [];

const GraffBox = ( arg ) => {

    let el;
    const fragment = document.createDocumentFragment();
    const element = document.getElementById('graff');
    let cont = element.children;

    for (let image in cont)
        if (cont[image].src !== undefined)
            urls.push(cont[image].src);

    element.innerHTML = '';
    let style = '';

    if(arg.gap != undefined)
        style += `grid-gap: ${arg.gap}; `;

    if(arg.columns != undefined)
        style += `grid-template-columns: ${arg.columns}; `;

    element.setAttribute('style', style);

    for (let img in urls) {
        el = document.createElement('img');
        el.setAttribute('src', urls[img]);

        if(arg.h != undefined && arg.w != undefined)
            el.setAttribute('style', `height: ${arg.h}px; width:${arg.w}px; max-width: 100%; max-height: 450px;`);
        else
            el.setAttribute('style', `height: 100%; max-width: 100%;`);

        el.setAttribute('onclick', `show('${urls[img]}')`);
        fragment.appendChild(el);
    }
    element.appendChild(fragment);
};

//utworzenie galerii do przewijania
show = (arg) => {

    let div = document.createElement('div');
    const div2 = document.createElement('div');
    let img = document.createElement('img');
    const closer = document.createElement('i');
    const listener = document.createElement('i');
    const rightArrow = document.createElement('span');
    const leftArrow = document.createElement('span');
    const counter = document.createElement('div');
    const counterFull = document.createElement('span');
    const counterNow = document.createElement('span');

    let next = urls.indexOf(`${arg}`);

    listener.setAttribute('id', 'list');
    listener.classList.add('fa');
    listener.classList.add('fa-ellipsis-h');
    listener.setAttribute('onclick', `box();`);

    counterNow.setAttribute('id', 'setNow');
    counterNow.innerHTML = next + 1 + '&nbsp;';
    counterFull.innerHTML = ` / ${urls.length}`;

    counter.setAttribute('id', 'counter');
    counter.appendChild(counterNow);
    counter.appendChild(counterFull);

    div2.setAttribute('id','gallery-content');

    closer.setAttribute('id', 'closer');
    closer.classList.add('fa');
    closer.classList.add('fa-close');
    closer.setAttribute('onclick', 'close();');

    leftArrow.setAttribute('id', 'graff-left-arrow');
    leftArrow.classList.add('fa');
    leftArrow.classList.add('fa-angle-left');
    leftArrow.setAttribute('onclick', `showPrev(${next-1});`);

    rightArrow.setAttribute('id', 'graff-right-arrow');
    rightArrow.classList.add('fa');
    rightArrow.classList.add('fa-angle-right');
    rightArrow.setAttribute('onclick', `showNext(${next+1});`);

    img.setAttribute('src', `${arg}`);
    img.setAttribute('id', 'displayer');

    div.appendChild(div2);
    div2.appendChild(img);
    div2.appendChild(listener);
    div2.appendChild(closer);
    div2.appendChild(rightArrow);
    div2.appendChild(leftArrow);
    div2.appendChild(counter);

    document.getElementsByTagName('body')[0].appendChild(div);
    div.setAttribute('id', 'graff-gallery');

    document.documentElement.style.overflow = 'hidden';
    document.documentElement.style.paddingRight = '17px';
    createImg();
    document.getElementById('closer').addEventListener('click', close = () => {
        let bodyDoc = document.getElementsByTagName('body')[0];
        div.classList.add('fadeOutdsdjpadoaj32onvpo345');
        setTimeout(() => {bodyDoc.removeChild(div)},700);
        document.documentElement.style.overflow = '';
        document.documentElement.style.paddingRight = '';
    });
};

//podmiana z małej listy
const replace = (item) => {
    if(urls[item.key] === undefined) return false;
    document.getElementById('displayer').setAttribute('src', item.url);
    createImg();
    document.getElementById('setNow').innerHTML = parseInt(item.key) + 1 +'&nbsp;';
    document.getElementById('graff-left-arrow').setAttribute('onclick', `showPrev(${(parseInt(item.key)-1)})`);
    document.getElementById('graff-right-arrow').setAttribute('onclick', `showNext(${(parseInt(item.key)+1)})`);
};

//zamykanie malej listy
const smallClose = () => {
    let child = document.getElementById('graffBoxList');
    let parent = document.getElementById('gallery-content');
    parent.removeChild(child);
};

//nastepne zdjęcie
const showNext = (item) => {
    if(urls[item] === undefined) return false;
    document.getElementById('displayer').setAttribute('src', urls[item]);
    createImg();
    document.getElementById('setNow').innerHTML = item  + 1 +'&nbsp;';
    document.getElementById('graff-left-arrow').setAttribute('onclick', `showPrev(${(item-1)})`);
    document.getElementById('graff-right-arrow').setAttribute('onclick', `showNext(${(item+1)})`);
};

//poprzednie zdjęcie
const showPrev = (item) => {
    if(urls[item] === undefined) return false;
    document.getElementById('displayer').setAttribute('src', urls[item]);
    createImg();
    document.getElementById('setNow').innerHTML = item + 1 +'&nbsp;';
    document.getElementById('graff-left-arrow').setAttribute('onclick', `showPrev(${(item-1)})`);
    document.getElementById('graff-right-arrow').setAttribute('onclick', `showNext(${(item+1)})`);
};

//utworzenie malego boxa w galerii z podgladem zdjec
const box = () => {
    if (!document.getElementById('graffBoxList')) {
        let el;
        let fragment = document.createDocumentFragment();
        let boxList = document.createElement('div');
        let smallCloser = document.createElement('span');
        boxList.setAttribute('id', 'graffBoxList');
        for (let img in urls) {
            el = document.createElement('img');
            el.setAttribute('src', urls[img]);
            el.classList.add('small-gallery-show');
            el.setAttribute('onclick', `replace({url : '${urls[img]}', key: '${img}'})`);
            fragment.appendChild(el);
        }
        smallCloser.classList.add('small-closer');
        smallCloser.classList.add('fa');
        smallCloser.classList.add('fa-close');
        smallCloser.setAttribute('onclick', 'smallClose();');
        // document.getElementById('graff-gallery').appendChild(smallCloser);
        boxList.appendChild(fragment);
        boxList.appendChild(smallCloser);
        document.getElementById('gallery-content').appendChild(boxList);
    }
};

//listener na strzalki oraz esc
document.addEventListener('keydown', (e) => {
    if (e.which === 27)
        close();
    if (e.which === 39)
        eval(document.getElementById('graff-right-arrow').getAttribute('onclick'));
    if (e.which === 37)
        eval(document.getElementById('graff-left-arrow').getAttribute('onclick'));
});

const createImg = () => {
    let img = document.getElementById('displayer');
    img.setAttribute('style', '');
    img.classList.remove('animator');
    setTimeout(() => {
        img.classList.add('animator');
        if(window.innerWidth > 991) {
            if (img.naturalHeight >= window.innerHeight || img.naturalWidth >= window.innerWidth)
                img.setAttribute('style', `height: ${window.innerHeight - 60}px; width: ${window.innerWidth - 130}px; opacity: 1;`);
            else
                img.setAttribute('style', 'opacity: 1');
        } else
            img.setAttribute('style', 'opacity: 1');

    },150);
    return null;
};
