class Carrito {

    constructor() {
        this._productos = [];
        this._totalPrice = 0;
        this._descuento = 0;
    }


    get productos() {
        return this._productos;
    }

    set productos(value) {
        this._productos = value;
    }

    get totalPrice() {
        return this._totalPrice;
    }

    set totalPrice(value) {
        this._totalPrice = value;
    }
    addProducto(product) {
        this._productos.push(product);
    }

    get descuento() {
        return this._descuento;
    }

    set descuento(value) {
        this._descuento = value;
    }
}