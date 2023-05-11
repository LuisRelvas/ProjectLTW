
document.getElementById('department-select').addEventListener('change', async function () {
    var selectedDepartment = this.value;
    console.log(selectedDepartment);
    const querie = '../api/showdepartments.api.php?value=' + selectedDepartment;
    const response = await fetch(querie)
    const departments = await response.json()
    const section = document.querySelector('#alldepartment')
    section.innerHTML = ''
    if (this.value.length == "") return;
    if (!Object.keys(departments).length) {
        const error = document.createElement('h3')
        error.textContent = "Não existem tickets com essas características"
        error.className = "error"
        section.appendChild(error)
    }
    for (const department of departments) {
        const article = document.createElement('article')
            const link = document.createElement('a')
            const tittle = document.createElement('h3')
            link.href = 'ticketseeonly.php?ticket_id=' + department.ticket_id
            link.textContent = department.ticket_id + ' --> ' + department.tittle
            article.appendChild(link)
            section.appendChild(article)

        
        

    }})
