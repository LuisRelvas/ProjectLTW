const searchTickets = document.querySelector("#searchticket")

if (searchTickets) {
    searchTickets.addEventListener('input', async function() {

        const typeSearch = document.querySelector("#critério")
        const querie = '../api/tickets.api.php?search=' + this.value + '&type=' + typeSearch.value
        const response = await fetch(querie)
        const tickets = await response.json()
        const section = document.querySelector('#searchtickets')
        section.innerHTML = ''
        if (this.value.length == "") return;

        if (!Object.keys(tickets).length) {
            const error = document.createElement('h3')
            error.textContent = "Não existem tickets com essas características"
            error.className = "error"
            section.appendChild(error)
        }

        for (const ticket of tickets) {
            const article = document.createElement('article')
            const link = document.createElement('a')
            link.href = 'ticketseeonly.php?ticket_id=' + ticket.ticket_id
            link.textContent = ticket.ticket_id
            article.appendChild(link)
            section.appendChild(article)
      }
  })
}