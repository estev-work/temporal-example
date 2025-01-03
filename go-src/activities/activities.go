package activities

import (
	"context"
	"errors"
	"go.temporal.io/sdk/activity"
)

// LogFromGolang activities
func LogFromGolang(ctx context.Context, idea Idea) (string, error) {
	if idea.ID == "" {
		return "", errors.New("invalid input: idea ID is empty")
	}
	activity.GetLogger(ctx).Info("Log Idea: ", "idea", idea)
	return "Idea " + idea.ID + " logged", nil
}
