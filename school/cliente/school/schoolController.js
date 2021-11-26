const url = "http://localhost:8080/Institute/school/servicio/public/index.php";

const getschoolsById = async (id) => {
    return await $.ajax({
        type: 'GET',
        url: url + '/school/' + id
    }).done(res => res);
};


const getId = async id =>{
    document.getElementById('idDel').value = id;
};

const getInfo = async id =>{
    let school = await getschoolsById(id);

    document.getElementById('name').value = school.school[0].name;
    document.getElementById('street').value = school.school[0].street;
    document.getElementById('created').value = school.school[0].created.date;
    document.getElementById('updated').value = school.school[0].updated.date;
    document.getElementById('status').value = school.school[0].status ? "Activo" : "Inactivo";

    console.log(product.product[0].name);
};

const getInfoUpdate = async id =>{
    let school = await getschoolsById(id);

    document.getElementById('idUp').value = school.school[0].id;
    document.getElementById('nameUp').value = school.school[0].name;
    document.getElementById('streetUp').value = school.school[0].street;

    console.log(school.schoo[0].name);
};


const getSchools = async () => {
    let table = "";
    await $.ajax({
        type: 'GET',
        url: url + '/school'
    }).done(function (res) {
        console.log(res);
        let results = res.listSchools;
        let table = $("table");

        for (let i = 0; i < results.length; i++) {
            table += `
                <tr>
                    <td> ${results[i].id}</td>
                    <td> ${results[i].name}</td>
                    <td> ${results[i].street}</td>
                    <td> ${results[i].status ? "Activo" : "Inactivo"}</td>
                    <td class="text-center">
                        <button onclick="getInfo(${results[i].id});" data-bs-toggle="modal" data-bs-target="#detalles" class="btn btn-outline-primary"><i class="fas fa-info-circle"></i></button>
                        <button onclick="getInfoUpdate(${results[i].id});" data-bs-toggle="modal" data-bs-target="#update" class="btn btn-outline-warning"><i class="fas fa-edit"></i></button>
                        <button onclick="getId(${results[i].id});" data-bs-toggle="modal" data-bs-target="#delete" class="btn btn-outline-danger"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>

            `
        }

        $(`#table`).html(table);
    });
};

const registerSchool = async () =>{
    let name = document.getElementById('nameReg').value;
    let street = document.getElementById('streetReg').value;

    await $.ajax({
        type: 'POST',
        url: url + '/school/create',
        data: {name, street}
    }).done(function(res){
        console.log(res);
        getSchools();
    });
}

const updateSchool = async () =>{
    let id = document.getElementById('idUp').value;
    let name = document.getElementById('nameUp').value;
    let street = document.getElementById('streetUp').value;
    console.log(id);

    await $.ajax({
        type: 'POST',
        url: url + '/school/update/'+id,
        data: {name, street}
    }).done(function(res){
        console.log(res);
        getSchools();
    });
};

const deleteSchool = async () =>{
    let id = document.getElementById('idDel').value;
    await $.ajax({
        type: 'GET',
        url: url + '/school/delete/' + id
    }).done(res => {
        console.log(res);
        getSchools();
    });
};

