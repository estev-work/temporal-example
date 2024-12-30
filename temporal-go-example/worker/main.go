package main

import (
    "go.temporal.io/sdk/activity"
    "go.temporal.io/sdk/client"
    "go.temporal.io/sdk/worker"
    "log"
    "temporal-go-example/activities"
)

func main() {
    // Client Temporal
    c, err := client.Dial(client.Options{
        HostPort:  client.DefaultHostPort,
        Namespace: client.DefaultNamespace,
    })
    if err != nil {
        log.Fatalln("Unable to create Temporal client", err)
    }
    defer c.Close()

    // Create Worker
    w := worker.New(c, activities.TaskQueueName, worker.Options{})
    w.RegisterWorkflow("IdeaWorkflow")
    // Register Activity
    w.RegisterActivityWithOptions(activities.LogFromGolang, activity.RegisterOptions{
        Name: "LogFromGolang",
    })
    w.RegisterActivity("CheckPayment")
    w.RegisterActivity("RejectedAfterTime")
    // Run Worker
    err = w.Run(worker.InterruptCh())
    if err != nil {
        log.Fatalln("Unable to start Worker.", err)
    }
}
