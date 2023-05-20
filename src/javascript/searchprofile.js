const searchProfiles = document.querySelector("#searchprofile")

if (searchProfiles) {
    searchProfiles.addEventListener('input', async function() {
        const csrf = event.currentTarget.previousElementSibling.value
        console.log(csrf)
        var currentUrl = new URL(window.location.href);
        var ticketId = currentUrl.searchParams.get("ticket_id");
        console.log(ticketId);
        
        const typeSearch = document.querySelector("#criterio1")
        const querie = '../api/profiles.api.php?search=' + this.value + '&type=' + typeSearch.value + '&csrf=' + csrf
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
        if(ticketId != null){
        for (const profile of profiles) {
            const article = document.createElement('article')
            const link = document.createElement('a')
            const tittle = document.createElement('h3')
            link.href = '/actions/assignticket.action.php?ticket_id=' + ticketId + '&id=' + profile.id
            link.textContent = '@' + profile.username;
            article.appendChild(link)
            section.appendChild(article)}}
        else { 
            for (const profile of profiles) {
            const article = document.createElement('article')
            const link = document.createElement('a')
            const tittle = document.createElement('h3')
            link.href = 'profile.php?id=' + profile.id + '&csrf=' + csrf
            link.textContent = '@' + profile.username
            article.appendChild(link)
            section.appendChild(article)}

        }
  })
}