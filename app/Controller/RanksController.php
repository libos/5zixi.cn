<?php
App::uses('AppController', 'Controller');

class RanksController extends AppController {
	public $components = array('Paginator');
	public function admin_index() {
    $this->layout = 'admin';
		$this->Rank->recursive = 0;
		$this->set('ranks', $this->Paginator->paginate());
	}

 	public function admin_view($id = null) {
    $this->layout = 'admin';
		if (!$this->Rank->exists($id)) {
			throw new NotFoundException(__('Invalid rank'));
		}
		$options = array('conditions' => array('Rank.' . $this->Rank->primaryKey => $id));
		$this->set('rank', $this->Rank->find('first', $options));
	}
 
	public function admin_add() {
    $this->layout = 'admin';
		if ($this->request->is('post')) {
			$this->Rank->create();
			if ($this->Rank->save($this->request->data)) {
				$this->Session->setFlash(__('The rank has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The rank could not be saved. Please, try again.'));
			}
		}
	}
 
	public function admin_edit($id = null) {
    $this->layout = 'admin';
		if (!$this->Rank->exists($id)) {
			throw new NotFoundException(__('Invalid rank'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Rank->save($this->request->data)) {
				$this->Session->setFlash(__('The rank has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The rank could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Rank.' . $this->Rank->primaryKey => $id));
			$this->request->data = $this->Rank->find('first', $options);
		}
	}

	public function admin_delete($id = null) {
		$this->Rank->id = $id;
		if (!$this->Rank->exists()) {
			throw new NotFoundException(__('Invalid rank'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Rank->delete()) {
			$this->Session->setFlash(__('The rank has been deleted.'));
		} else {
			$this->Session->setFlash(__('The rank could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
