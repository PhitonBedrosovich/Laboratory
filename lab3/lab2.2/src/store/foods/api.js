import Api from '@/api/index';

class Foods extends Api {

  constructor() {
    super('http://localhost/crud_rest'); // Указываем базовый URL
  }

  foods = () => this.rest('/foods/list.json');

  remove = (id) => {
    const formData = new FormData();
    formData.append('id', id);

    return this.rest('/foods/delete-item', {
      method: 'POST',
      body: formData
    }).then(response => response.json());
  };

  foodId = (dishID) => this.rest(`/foods/SelectByID?id_dishes=${dishID}`);

  add = (food) => {

    const formData = new FormData();
    formData.append('name', food.name);
    formData.append('img_path', food.img_path);
    formData.append('id_dishes', food.id_dishes);
    formData.append('description', food.description);
    formData.append('weight', food.weight);


    return this.rest('/foods/add-item', {
      method: 'POST',
      body: formData
    }).then(response => response.json());
  };

  update = ( food ) => {
    const formData = new FormData();
    formData.append('id', food.id);
    formData.append('name', food.name);
    formData.append('img_path', food.img_path);
    formData.append('id_dishes', food.id_dishes);
    formData.append('description', food.description);
    formData.append('weight', food.weight);

    return this.rest('/foods/update-item', {
      method: 'POST',
      body: formData
    }).then(response => response.json());
  };
}

export default new Foods();
