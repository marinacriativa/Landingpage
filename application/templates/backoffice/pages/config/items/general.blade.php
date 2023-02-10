<h4 class="inline">Famílias</h4>
<div class="top-right-button-container ">
    <button type="button" class="btn btn-outline-primary btn-xs new-family">Nova família</button>
</div>
<hr>
<table class="table">
    <thead class="thead-light">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nome</th>
            <th scope="col">Cor</th>
            <th scope="col">Ações</th>
        </tr>
    </thead>
    <tbody id="clients-families">
        <tr>
            <th scope="row">1</th>
            <td>Cliente</td>
            <td><span class="background-color" style="background:#3398db"></span></td>
            <td>
                <div class="row">
                    <button type="button" class="btn btn-outline-primary btn-xs mr-2" data-family="1" data-name="Cliente" data-color="#3398db">Editar</button>
                    <button type="button" class="btn btn-outline-danger btn-xs mr-auto" data-family-delete="1">Remover</button>
                </div>
            </td>
        </tr>
        <tr>
            <th scope="row">2</th>
            <td>Lead</td>
            <td><span class="background-color" style="background:#f39c19"></span></td>
            <td>
                <div class="row">
                    <button type="button" class="btn btn-outline-primary btn-xs mr-2" data-family="2" data-name="Lead" data-color="#f39c19">Editar</button>
                    <button type="button" class="btn btn-outline-danger btn-xs mr-auto" data-family-delete="2">Remover</button>
                </div>
            </td>
        </tr>
        <tr>
            <th scope="row">3</th>
            <td>Parceiro</td>
            <td><span class="background-color" style="background:#1ca085"></span></td>
            <td>
                <div class="row">
                    <button type="button" class="btn btn-outline-primary btn-xs mr-2" data-family="3" data-name="Parceiro" data-color="#1ca085">Editar</button>
                    <button type="button" class="btn btn-outline-danger btn-xs mr-auto" data-family-delete="3">Remover</button>
                </div>
            </td>
        </tr>
    </tbody>
</table>