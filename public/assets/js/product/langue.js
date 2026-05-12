
const languageSelector = document.getElementById('languageSelector');
const dropdownToggle = document.getElementById('languageDropdownToggle');
const dropdownMenu = document.getElementById('languageDropdownMenu');

if (languageSelector && dropdownToggle && dropdownMenu) {

    dropdownToggle.addEventListener('click', function (e) {
        e.preventDefault();
        e.stopPropagation();


        if (languageSelector.classList.contains('active')) {
            languageSelector.classList.remove('active');
            dropdownMenu.style.display = 'none';
        } else {
            languageSelector.classList.add('active');
            dropdownMenu.style.display = 'block';
        }
    });

    document.addEventListener('click', function (e) {
        if (!languageSelector.contains(e.target)) {
            languageSelector.classList.remove('active');
            dropdownMenu.style.display = 'none';
        }
    });

    dropdownMenu.addEventListener('click', function (e) {
        e.stopPropagation();
    });

}