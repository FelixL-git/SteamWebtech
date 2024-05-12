const allSeries = [];

const searchFor = {
    title: true,
    genre: true,
    platform: true,
}

// load series data into JSON
function loadSeriesData() {
    // get data attribut from all series and push it into an array
    document.querySelectorAll('[data-series]').forEach((element) => {
        const dataJSON = JSON.parse(element.dataset.series);
        allSeries.push(dataJSON);
    });
}

// update visibility based in search
function updateSeriesVisibility(seriesToShow) {
    // for every series check if in seriesToShow
    // show (remove hide) if it is in seriesToShow
    allSeries.forEach((series) => {
        const seriesElement = document.getElementById(series.id);
        if (seriesToShow.includes(series)) {
            seriesElement.classList.remove('hide');
        } else {
            seriesElement.classList.add('hide');
        }
    });
}

// filter series based on search term
function performSearch(searchTerm) {
    // Filters all series to see if the searchTerm is included in the checked searchFor 
    // Filter returns a new list 
    // Some only returns true or false (depending on whether it has found one or not)
    const searchedSeries = allSeries.filter((series) => {
        return Object.keys(searchFor).some((key) => {
            return searchFor[key] && series[key] && series[key].toLowerCase().includes(searchTerm);
        });
    });

    updateSeriesVisibility(searchedSeries);
}

// add event listner on textinput (keyup) and checkbox (change)
// call performSearch after that
function setupEventListeners() {
    // listen for every key input in textinput
    // then perform search with textinput (searchTerm)
    document.getElementById('search').addEventListener('keyup', (event) => {
        const searchTerm = event.target.value.toLowerCase();
        performSearch(searchTerm);
    });

    // listen for change in every checkbox ('title', 'genre', 'platform')
    // then chnage searchFor[key] 
    // then perform search with textinput (searchTerm)(to update results)
    ['title', 'genre', 'platform'].forEach((key) => {
        document.getElementById(`${key}-checkbox`).addEventListener('change', (event) => {
            searchFor[key] = event.target.checked;
            const searchTerm = document.getElementById('search').value.toLowerCase();
            performSearch(searchTerm);
        });
    });
}

// init function only for better overview
function init() {
    const isDashboardPage = document.querySelector('.page-dashboard');
    if(isDashboardPage){
        loadSeriesData(); // first load all Data into JSON
        setupEventListeners(); // setup listeners for inputs
    
        const openBtn = document.querySelector('.open-add-series-form');
        const popup = document.querySelector('.add-series-form');
        const closeBtn = document.querySelector('.add-series-form_close');
    
        openBtn.addEventListener('click', () => {
            popup.classList.add('show')
        })
    
        closeBtn.addEventListener('click', () => {
            popup.classList.remove('show')
        })
    }
}

function showRegister() {
    var regForm = document.getElementById("registerForm");
    var logForm = document.getElementById("loginForm");
    var switchToLogin = document.getElementById("showLoginForm");
    var switchToRegister = document.getElementById("showRegisterForm");
    regForm.style.display = "block";
    logForm.style.display = "none";
    switchToLogin.style.display = "block";
    switchToRegister.style.display = "none";
}
function showLogin() {
    var regForm = document.getElementById("registerForm");
    var logForm = document.getElementById("loginForm");
    var switchToLogin = document.getElementById("showLoginForm");
    var switchToRegister = document.getElementById("showRegisterForm");
    regForm.style.display = "none";
    logForm.style.display = "block";
    switchToLogin.style.display = "none";
    switchToRegister.style.display = "block";
}

// call init function
init();