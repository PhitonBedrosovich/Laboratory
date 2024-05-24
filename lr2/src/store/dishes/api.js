import Api from '@/api/index';

class Dishes extends Api {

  /**
   * Вернет список всех студентов
   * @returns {Promise<Response>}
   */
  dishes = () => this.rest('/dishes/list.json');

  /**
   * Удалит студента по id
   * @param id
   * @returns {Promise<*>}
   */
  remove = ( id ) => this.rest('/dishes/delete-item', {
    method: 'POST',
    'Content-Type': 'application/json',
    body: JSON.stringify({ id }),
  }).then(() => id) // then - заглушка, пока метод ничего не возвращает

  /**
   * Создаст новую запись в таблице
   * @param dish объект студента, взятый из FormStudent
   * @returns {Promise<Response>}
   */
  add = ( dish ) => this.rest('/dishes/add-item', {
    method: 'POST',
    'Content-Type': 'application/json',
    body: JSON.stringify(dish),
  }).then(() => ({...dish, id: new Date().getTime()})) // then - заглушка, пока метод ничего не возвращает

  /**
   * Отправит измененную запись
   * @param dish объект студента, взятый из FormStudent
   * @returns {Promise<*>}
   */
  update = ( dish ) => this.rest('/dishes/update-item', {
    method: 'POST',
    'Content-Type': 'application/json',
    body: JSON.stringify(dish),
  }).then(() => dish) // then - заглушка, пока метод ничего не возвращает

}

export default new Dishes();
