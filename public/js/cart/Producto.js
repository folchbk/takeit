class Producto {

    constructor(id, title, description, price, category) {
        this._id = id;
        this._title = title;
        this._description = description;
        this._price = price;
        this._category = category;
        this._quantity = 0;
    }

    get id() {
        return this._id;
    }

    set id(value) {
        this._id = value;
    }

    get title() {
        return this._title;
    }

    set title(value) {
        this._title = value;
    }

    get description() {
        return this._description;
    }

    set description(value) {
        this._description = value;
    }

    get price() {
        return this._price;
    }

    set price(value) {
        this._price = value;
    }

    get category() {
        return this._category;
    }

    set category(value) {
        this._category = value;
    }

    get quantity() {
        return this._quantity;
    }

    set quantity(value) {
        this._quantity = value;
    }

    upQuantity() {
        this._quantity++;
    }
    downQuantity() {
        if (this._quantity > 0)  this._quantity--;
    }
}