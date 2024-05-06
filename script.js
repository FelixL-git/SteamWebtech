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
    loadSeriesData(); // first load all Data into JSON
    setupEventListeners(); // setup listeners for inputs
}

// call init function
init();