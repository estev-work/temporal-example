package activities

const TaskQueueName string = "default"

// Idea структура идеи из php
type Idea struct {
	ID          string  `json:"id"`
	Title       string  `json:"title"`
	Description string  `json:"description"`
	Status      string  `json:"status"`
	Price       int     `json:"price"`
	Currency    string  `json:"currency"`
	CreatedAt   string  `json:"createdAt"`
	UpdatedAt   *string `json:"updatedAt"`
}
