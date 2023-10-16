class Ecommerce {

    constructor() {
        this.api_key = "API_KEY=a0ad8a6b-6727-46f4-8bee-2c6ce6293e41";
        this.api = "http://localhost/MastClassEcommerce/Backend/api/";
        this.actions = ["orders", "users", "category", "products"];
        this.data = [];
        this.initRouter();
        this.initDataApp();
    }

    initRouter() {
        this.actions.forEach((action) => {
            document.getElementById(action).addEventListener('click', () => {
                fetch('templates/' + action + '.html')
                    .then((response) => {
                        if (response.ok) {
                            return response.text();
                        } else {
                            console.log('Erreur de chargement du template')
                        }
                    }).then((data) => {
                        document.getElementsByClassName('container-fluid')[0].innerHTML = data;
                        if (action == 'products') {
                            this.loadProducts();
                        } else if (action == 'category') {
                            this.loadCategory();
                        } else if (action == 'users') {
                            this.loadUsers();
                        } else if (action == 'orders') {
                            this.loadOrders();
                        }
                    })
            })
        })
    }

    initDataApp() {
        this.actions.forEach((action) => {
            const url = this.api + action + "?" + this.api_key;
            fetch(url)
                .then((response) => {
                    if (response.ok) {
                        return response.json()
                    } else {
                        console.log("Erreur de chargement des données")
                    }
                }).then((response) => {
                    if (response.status == 200) {
                        // localStorage.setItem(action, JSON.stringify(response.result));
                        this.data.push({ name: action, data: response.result });

                    }
                })
        })
    }

    getData(action) {
        var object = this.data.find(element => element.name == action);
        return object.data;
        // return JSON.parse(localStorage.getItem(entity)) ? JSON.parse(localStorage.getItem(entity)) : [];

    }

    loadProducts() {
        $('#dataTable').DataTable({
            data: this.getData('products'),
            columns: [
                { data: 'idProduct' },
                { data: 'name' },
                { data: 'description' },
                {
                    data: 'price',
                    render: function (data, type, row) {
                        return '€' + data;
                    }
                },
                { data: 'stock' },
                { data: 'createdAt' },
                {
                    data: 'idProduct',
                    render: function (id, type, row) {
                        return `<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#updateProduct-${id}">UPDATE</button>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteProduct-${id}">DELETE</button>

                        <!-- MODAL UPDATE PRODUCT-->
                       <div class="modal fade" id="updateProduct-${id}" tabindex="-1" aria-labelledby="updateProductModalLabel" aria-hidden="false">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h2 class="modal-title" id="updateModalLabel">Update Product</h2>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                <div class="modal-body">
                                    <form action="" id="formUpdateProduct-${id}">
                                        <div class="form-row">
                                            <div class="col">
                                                <label for="recipient-name" class="col-form-label">Name : </label>
                                                <input  type="text" name="name" value="${row.name}" class="form-control" id="recipient-name">
                                               
                                                <span class="">This field is required</span >
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col">
                                                <label for="" class="col-form-label">Description : </label>
                                                <textarea  class="form-control" name="description" cols="30" rows="10" id="message-text">${row.description}</textarea>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <label for="" class="col-form-label">Price : </label>
                                            <input  name="price" type="number" value="${row.price}" class="form-control" cols="30" rows="10" id="message-text"></input>
                                        </div>
                                        <div class="col">
                                            <label for="" class="col-form-label">Stock : </label>
                                            <input  name="stock" type="number" value="${row.stock}" class="form-control" cols="30" rows="10" id="message-text"></input>
                                        </div>
                                        <div class="col">
                                            <label for="category">Category : </label>
                                            <select name="category" value="${row.category}" class="form-control" required>
                                                <option selected>Open this select Category</option>
                                                <option value="1">One</option>
                                                <option value="2">Two</option>
                                                <option value="3">Three</option>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <label for="image" class="col-form-label">Image : </label>
                                            <input  name="image" type="file" class="form-control" cols="30" rows="10" accept="image>
                                        </div>
                                    </form>
                                </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="updateProduct(${id}, '${row.image}')">Update Product</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="deleteProduct-${id}" tabindex="-1" aria-labelledby="deleteProductModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h2 class="modal-title" id="deleteModalLabel">Confirmation message</h2>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure you want to delete this product? We remind you that this action is irreversible.</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="deleteProduct(${id})">Delete Product</button>
                                    </div>
                                </div>
                            </div>
                        </div>        
                        
                        

                        <!-- Modal -->
                        <div class="modal fade" id="deleteProduct-${id}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        ...
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary">Save changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        `;
                    }
                }

            ]
        });
    }
    loadCategory() {
        $('#dataTable').DataTable({
            data: this.getData('category'),
            columns: [
                { data: 'idCategory' },
                { data: 'name' },
            ]
        });
    }
    loadUsers() {
        $('#dataTable').DataTable({
            data: this.getData('users'),
            columns: [
                { data: 'idUser' },
                { data: 'email' },
                { data: 'firstname' },
                { data: 'lastname' },
            ]
        })
    }
    loadOrders() {
        $('#dataTable').DataTable({
            data: this.getData('orders'),
            columns: [
                { data: 'idOrder' },
                { data: 'idUser' },
                { data: 'idProduct' },
                { data: 'quantity' },
                { data: 'price' },
                { data: 'createdAt' },
            ]
        })
    }

}

export { Ecommerce }