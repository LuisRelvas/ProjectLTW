
document.getElementById('status-select').addEventListener('change', async function () {
    var selectedStatus = this.value;
    console.log(selectedStatus);
    const querie = '../api/showstatus.api.php?value=' + selectedStatus;
    const response = await fetch(querie)
    const status = await response.json()
    const section = document.querySelector('#allstatus')
    section.innerHTML = ''
    if (this.value.length == "") return;
    if (!Object.keys(status).length) {
        const error = document.createElement('h3')
        error.textContent = "Não existem tickets com essas características"
        error.className = "error"
        section.appendChild(error)
    }
    for (const statu of status) {
        const article = document.createElement('article')
            const link = document.createElement('a')
            const tittle = document.createElement('h3')
            link.href = 'ticketseeonly.php?ticket_id=' + statu.ticket_id
            link.textContent = statu.ticket_id + ' --> ' + statu.tittle
            article.appendChild(link)
            section.appendChild(article)

        
        

    }})
