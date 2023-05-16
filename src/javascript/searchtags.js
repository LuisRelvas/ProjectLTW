const searchTags = document.querySelector("#searchtag")

if (searchTags) {
    searchTags.addEventListener('input', async function() {

        const typeSearch = document.querySelector("#critério2")
        const querie = '../api/hashtags.api.php?search=' + this.value + '&type=' + typeSearch.value
        const response = await fetch(querie)
        const tags = await response.json()
        const section = document.querySelector('#searchtags')
        section.innerHTML = ''
        if (this.value.length == "") return;

        if (!Object.keys(tags).length) {
            const error = document.createElement('h3')
            error.textContent = "Não existem tags com essas características"
            error.className = "error"
            section.appendChild(error)
        }
        for (const tag of tags) {
            const article = document.createElement('article')
            const link = document.createElement('a')
            const tittle = document.createElement('h3')
            link.href = '../actions/addHashtag.action.php?tag=' + tag.tag
            link.textContent = tag.tag
            article.appendChild(link)
            section.appendChild(article)
        
      }
  })
}