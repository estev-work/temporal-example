package main

import (
	"go.temporal.io/sdk/activity"
	"go.temporal.io/sdk/client"
	temporallog "go.temporal.io/sdk/log"
	"go.temporal.io/sdk/worker"
	golog "log"
	"log/slog"
	"os"
	"temporal-go-example/activities"
)

func main() {
	logFile, err := os.OpenFile("app.log", os.O_APPEND|os.O_CREATE|os.O_WRONLY, 0644)
	if err != nil {
		golog.Fatalf("Failed to open log file: %v", err)
	}
	defer func(logFile *os.File) {
		err := logFile.Close()
		if err != nil {
			golog.Fatalf("Failed to close log file: %v", err)
		}
	}(logFile)

	opts := &slog.HandlerOptions{
		Level:     slog.LevelDebug,
		AddSource: false,
	}
	appLogger := slog.New(slog.NewJSONHandler(logFile, opts))

	// Client Temporal
	c, err := client.Dial(client.Options{
		HostPort:  client.DefaultHostPort,
		Namespace: client.DefaultNamespace,
		Logger:    temporallog.NewStructuredLogger(appLogger),
	})
	if err != nil {
		golog.Fatalln("Unable to create Temporal client", err)
	}
	defer c.Close()

	// Create Worker
	w := worker.New(c, activities.TaskQueueName, worker.Options{})

	// Register Activity
	w.RegisterActivityWithOptions(activities.LogFromGolang, activity.RegisterOptions{
		Name: "LogFromGolang",
	})

	// Run Worker
	err = w.Run(worker.InterruptCh())
	if err != nil {
		golog.Fatalln("Unable to start Worker.", err)
	}
}
