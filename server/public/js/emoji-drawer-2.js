const { createPopup } = window.picmoPopup;
const { TwemojiRenderer } = window.picmoTwemoji;
const { autoTheme } = window.picmo.autoTheme;
const { lightTheme } = window.picmo.lightTheme;
const { darkTheme } = window.picmo.darkTheme;
var lamp;
switch (LDthemetype) {
    case 'dark':
        lamp = darkTheme;
        break;
    case 'light':
        lamp = lightTheme;
    default:
        lamp = autoTheme;
        break;
}

document.addEventListener('DOMContentLoaded', () => {
    const selectionContainer = document.querySelector('#selection-outer');
    const inputEle = document.querySelector('#feelemojiinput');
    const emojbttn = document.querySelector('#feelemojibutton');

    const picker = createPopup({}, {
        referenceElement: document.getElementById('AddEntryFormDiv'),
        emojbttnElement: emojbttn,
        position: 'center',
        theme: lamp,
        hideOnClickOutside: false,
        className: "emoji-drawer-2",
        // emojisPerRow: 6,
        // emojiSize: '1.3em',
        maxRecents: 8,
        PositionLostStrategy: "hold",
    });

    emojbttn.addEventListener('click', () => {
        picker.toggle();
    });

    picker.addEventListener('emoji:select', (selection) => {
        inputEle.value = selection.emoji;
        emojbttn.innerText = selection.emoji;
        selectionContainer.classList.remove('empty');
    });
});