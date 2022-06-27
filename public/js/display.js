let link = document.getElementsByClassName('atom_word_search_result__matches_link');
let article_text = document.getElementsByClassName('article__text');

for (let i = 0; i < link.length; i++) {
    link[i].addEventListener('click', () => {
        if (article_text[i].style.display == 'none') {
            // Проверка, отображается ли другая статья
            let num = check_if_text_visible();
            if (num !== '-1') {
                article_text[num].style.display = 'none';
                article_text[i].style.display = 'block';
            }
            else {
            article_text[i].style.display = 'block';
            }
        }
        else {
            article_text[i].style.display = 'none';
        }
    })
}

function check_if_text_visible() {
    for (let i = 0; i < article_text.length; i++) {
        if (article_text[i].style.display == 'block') {
            article_text[i].style.display = 'none';
        }
        else {
            return '-1';
        }
    }
}
