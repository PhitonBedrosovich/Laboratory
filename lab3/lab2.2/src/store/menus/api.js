import Api from '@/api/index';

class Menus extends Api {

  constructor() {
    super('http://localhost/crud_rest'); // Указываем базовый URL
  }
  /**
   * Вернет список всех ресторанов
   * @returns {Promise<Response>}
   */
  menus = () => this.rest('/menus/list.json');

  /**
   * Удалит ресторан по id
   * @param id
   * @returns {Promise<*>}
   */
  remove = (id) => {
      const formData = new FormData();
      formData.append('id', id);

      return this.rest('/menus/delete-item', {
          method: 'POST',
          body: formData
      }).then(response => response.json());
  };

    /**
   * Создаст новую запись в таблице
   * @param menu объект группы, взятый из FormMenu
   * @returns {Promise<Response>}
   */
  add = (menu) => {
      const formData = new FormData();
      formData.append('name', menu.name);


      return this.rest('/menus/add-item', {
          method: 'POST',
          body: formData
      }).then(response => response.json());
  };
  /**
   * Отправит измененную запись
   * @param menu объект группы, взятый из FormGroup
   * @returns {Promise<*>}
   */
 update = (menu) => {
    const formData = new FormData();
    formData.append('id', menu.id);
    formData.append('name', menu.name);
     formData.append('username24', menu.name);//добавил//username->username24

    return this.rest('/menus/update-item', {
      method: 'POST',
      body: formData
    }).then(response => response.json());
  };
}

export default new Menus();
