
document.getElementById('hashtag-select').addEventListener('change', async function () {
    var selectedHashtag = this.value;
    console.log(selectedHashtag);
    const querie = '../api/showhashtags.api.php?value=' + selectedHashtag;
    const response = await fetch(querie)
    const hashtags = await response.json()
    console.log(hashtags);
    const section = document.querySelector('#allhashtag')
    section.innerHTML = ''
    if (this.value.length == "") return;
    if (!Object.keys(hashtags).length) {
        const error = document.createElement('h3')
        error.textContent = "Não existem tickets com essas características"
        error.className = "error"
        section.appendChild(error)
    }
    for (const hashtag of hashtags) {
        const article = document.createElement('article')
            const link = document.createElement('a')
            const tittle = document.createElement('h3')
            link.href = 'ticketseeonly.php?ticket_id=' + hashtag.ticket_id
            link.textContent = hashtag.ticket_id + ' --> ' + hashtag.tittle
            article.appendChild(link)
            section.appendChild(article)

        
        

    }})
