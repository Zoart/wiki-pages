let link = document.getElementsByClassName('atom_word_search_result__matches_link');
let article_text = document.getElementsByClassName('article__text');
let article_result_text = document.querySelector('.atom_word_search_result__articles');


let number_of_articles = article_text.length;

let active = -1;

function show_page() {
    for (let i = 0; i < link.length; i++) {
        link[i].addEventListener('click', () => {
            if (article_text[i].style.display == 'none') {
                check_active(i)
                article_text[i].style.display = 'block';
                active = i;
            }
            else {
                check_active(i)
                article_text[i].style.display = 'none'
            }
        })
    }
};

function check_active(current_article) {
    if (active !== -1 && current_article !== active) {
        article_text[active].style.display = 'none'
        active = -1;
    }
}



function display_none_for_all() {
    for (let i = 0; i < number_of_articles; i++) {
        if (article_text[i].style.display == 'block') {
            article_text[i].style.display = 'none';
        }
    }
}

document.onload = show_page();
