import Api from '@/api/index';

class Menus extends Api {

  /**
   * Вернет список всех групп
   * @returns {Promise<Response>}
   */
  menus = () => this.rest('/menus/list.json');

  /**
   * Удалит группу по id
   * @param id
   * @returns {Promise<*>}
   */
  remove = ( id ) => this.rest('/menus/delete-item', {
    method: 'POST',
    'Content-Type': 'application/json',
    body: JSON.stringify({ id }),
  }).then(() => id) // then - заглушка, пока метод ничего не возвращает

  /**
   * Создаст новую запись в таблице
   * @param menu объект группы, взятый из FormMenu
   * @returns {Promise<Response>}
   */
  add = ( menu ) => this.rest('menus/add-item', {
    method: 'POST',
    'Content-Type': 'application/json',
    body: JSON.stringify(menu),
  }).then(() => ({...menu, id: new Date().getTime()})) // then - заглушка, пока метод ничего не возвращает

  /**
   * Отправит измененную запись
   * @param menu объект группы, взятый из FormMenu
   * @returns {Promise<*>}
   */
  update = ( menu ) => this.rest('menus/update-item', {
    method: 'POST',
    'Content-Type': 'application/json',
    body: JSON.stringify(menu),
  }).then(() => menu) // then - заглушка, пока метод ничего не возвращает

}

export default new Menus();
