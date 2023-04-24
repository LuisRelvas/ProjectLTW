const searchProfiles = document.querySelector("#searchprofile")

if (searchProfiles) {
    searchProfiles.addEventListener('input', async function() {

        const typeSearch = document.querySelector("#critério1")
        const querie = '../api/profiles.api.php?search=' + this.value + '&type=' + typeSearch.value
        const response = await fetch(querie)
        const profiles = await response.json()
        const section = document.querySelector('#searchprofiles')
        section.innerHTML = ''
        if (this.value.length == "") return;

        if (!Object.keys(profiles).length) {
            const error = document.createElement('h3')
            error.textContent = "Não existem profiles com essas características"
            error.className = "error"
            section.appendChild(error)
        }

        for (const profile of profiles) {
            const article = document.createElement('article')
            const link = document.createElement('a')
            const tittle = document.createElement('h3')
            link.href = 'profile.php?id=' + profile.id
            link.textContent = profile.id + ' --> ' + profile.username
            article.appendChild(link)
            section.appendChild(article)
      }
  })
}